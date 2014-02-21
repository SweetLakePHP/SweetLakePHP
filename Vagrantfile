# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.define "dev", primary: true do |config_dev|
        config_dev.vm.box = "debian64"
        config_dev.vm.box_url = "http://vagrantboxes.future500.nl/vagrant-debian64.box"

        config_dev.vm.network :private_network, ip: "192.168.30.48"
        config_dev.vm.synced_folder ".", "/vagrant", nfs: true

        config_dev.vm.provider :virtualbox do |vb|
            vb.name = "sweetlakephp_development"
        end

        config_dev.vm.provision :ansible do |ansible|
            ansible.inventory_path = "ansible/hosts"
            ansible.playbook       = "ansible/provision.yml"
            ansible.limit          = "vagrant"
        end
    end

=begin
This block was disabled on puprpose so developers won't have an additional (unused) sweetlakephp_production virtual machine
    config.vm.define "prod" do |config_prod|
        config_prod.vm.box = "debian64"
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
=end

end



