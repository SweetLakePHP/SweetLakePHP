# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

# These variables are set to re-use them in the bash provisioner and ansible settings
vagrant_share = "/vagrant"
ansible_playbook = "ansible/provision.yml"

$WINDOWS_PROVISIONING_SCRIPT = <<SCRIPT
#!/usr/bin/env bash

export DEBIAN_FRONTEND=noninteractive

apt-get update -qq
apt-get install -y make git-core

ANSIBLE_INSTALLED=`which ansible-playbook | wc -l`

if [[ "$ANSIBLE_INSTALLED" == "0" ]]; then
    # Install Ansible dependencies.
    apt-get install -y python-mysqldb python-yaml python-jinja2 python-paramiko sshpass

    # Checkout the Ansible repository.
    sudo -u vagrant git clone --depth 1 https://github.com/ansible/ansible.git /home/vagrant/ansible

    # Add the Vagrant insecure private key
    sudo -u vagrant mkdir /home/vagrant/.vagrant.d
    sudo -u vagrant touch /home/vagrant/.vagrant.d/insecure_private_key
    sudo -u vagrant chmod 600 /home/vagrant/.vagrant.d/insecure_private_key
    sudo -u vagrant wget -q -O /home/vagrant/.vagrant.d/insecure_private_key https://raw.githubusercontent.com/mitchellh/vagrant/master/keys/vagrant

    sudo -u vagrant source /home/vagrant/ansible/hacking/env-setup
    echo "source /home/vagrant/ansible/hacking/env-setup" >> /home/vagrant/.bashrc
fi

cd #{vagrant_share}
sudo -u vagrant PYTHONUNBUFFERED=1 ansible-playbook #{ansible_playbook} --limit vagrant
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.define "sweetlake-development", primary: true do |config_dev|
        config_dev.vm.box = "f500/debian-wheezy64"

        config_dev.vm.network :private_network, ip: "192.168.30.48"
        config_dev.vm.synced_folder ".", vagrant_share, rsync: true

        config_dev.vm.provider :virtualbox do |vb|
            vb.name = "sweetlakephp_development"
        end

        if Gem.win_platform?
            config.vm.provision :shell,
            :inline => $WINDOWS_PROVISIONING_SCRIPT
        else
            config_dev.vm.provision :ansible do |ansible|
                ansible.inventory_path = "ansible/hosts"
                ansible.playbook       = ansible_playbook
                ansible.limit          = "vagrant"
            end
        end
    end

    if ENV["ENABLE_PROD"] == "true"
        config.vm.define "sweetlake-simulate-production" do |config_prod|
            config_prod.vm.box = "f500/debian-wheezy64"
            config_prod.vm.network :private_network, ip: "192.168.30.49"
            config.vm.synced_folder ".", "/vagrant", nfs:false, disabled: true

            config_prod.vm.provider :virtualbox do |vb|
                vb.name = "sweetlakephp_production"
            end

            config_prod.vm.provision :ansible do |ansible|
                ansible.inventory_path = "ansible/hosts"
                ansible.playbook       = "ansible/setup_local_production_server.yml"
                ansible.limit          = "production-test"
                ansible.raw_arguments  = "--user=vagrant"
                ansible.raw_arguments  = "--private-key=~/.vagrant.d/insecure_private_key"
                ansible.host_key_checking  = "False"
            end
        end
    end

end
